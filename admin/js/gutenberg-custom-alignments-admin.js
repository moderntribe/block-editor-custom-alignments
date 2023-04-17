(function() {
	'use strict';

	// grab WP variables necessary for the module
	const {
		__,
	} = wp.i18n;

	const {
		BlockControls,
	} = wp.blockEditor;

	const {
		ToolbarDropdownMenu,
		ToolbarGroup,
	} = wp.components;

	const {
		createHigherOrderComponent,
	} = wp.compose;

	const {
		getBlockSupport,
	} = wp.blocks;

	const {
		Fragment,
		createElement,
	} = wp.element;

	// add shortcut for creating an element
	const el = createElement;

	// get alignment from global enqueued theme.json object
	const themeJSON = tribe.theme_json;

	// add object of WP default alignments
	const defaultWPAlignments = [
		{
			name: 'None',
			slug: 'none',
			icon: 'M5 15h14V9H5v6zm0 4.8h14v-1.5H5v1.5zM5 4.2v1.5h14V4.2H5z',
			width: themeJSON.settings.layout.contentSize,
			textdomain: 'tribe'
		},
		{
			name: 'Wide width',
			slug: 'wide',
			icon: 'M5 9v6h14V9H5zm11-4.8H8v1.5h8V4.2zM8 19.8h8v-1.5H8v1.5z',
			width: themeJSON.settings.layout.wideSize,
			textdomain: 'tribe'
		},
		{
			name: 'Full width',
			slug: 'full',
			icon: 'M5 4v11h14V4H5zm3 15.8h8v-1.5H8v1.5z',
			width: '100%',
			textdomain: 'tribe'
		}
	];

	// add object of WP default justifcations
	const defaultWPJustifcations = [
		{
			name: 'Align left',
			slug: 'left',
			icon: 'M4 9v6h14V9H4zm8-4.8H4v1.5h8V4.2zM4 19.8h8v-1.5H4v1.5z',
			width: false,
			textdomain: 'tribe'
		},
		{
			name: 'Align center',
			slug: 'center',
			icon: 'M7 9v6h10V9H7zM5 19.8h14v-1.5H5v1.5zM5 4.3v1.5h14V4.3H5z',
			width: false,
			textdomain: 'tribe'
		},
		{
			name: 'Align right',
			slug: 'right',
			icon: 'M6 15h14V9H6v6zm6-10.8v1.5h8V4.2h-8zm0 15.6h8v-1.5h-8v1.5z',
			width: false,
			textdomain: 'tribe'
		}
	];

	// add array of global blocks to exclude from getting custom support
	// TODO: maybe add this to theme.json as well?
	const excludeBlocksFromCustomAlignmentSupport = [];

	/**
	 * @function modifyBlockAlignmentSupport
	 *
	 * @description Disables default alignment support on all blocks that currently offer it and adds our own custom alignment settings from theme.json
	 *
	 * @param {*} settings
	 * @param {*} name
	 *
	 * @returns
	 */
	const modifyBlockAlignmentSupport = ( settings, name ) => {
		// disable specific blocks from having custom alignment support
		if ( excludeBlocksFromCustomAlignmentSupport.includes( name ) ) {
			return settings;
		}

		// check if the block we're viewing has alignment support in the first place and return early if
		const hasAlignSupport = settings?.supports?.align !== undefined;

		if ( ! hasAlignSupport ) {
			return settings;
		}

		// Get the original align values from the block supports settings
		let originalAlignSupport = settings.supports.align;

		// Modify the default block supports settings
		const newSettings = {
			...settings,
			supports: {
				...settings.supports,
				align: false, // This will disable the default align to hide the core block alignment toolbar
				alignCustom: originalAlignSupport, // We clone the default align and store it here instead
			}
		};

		return newSettings;
	};

	wp.hooks.addFilter( 'blocks.registerBlockType', 'tribe/modify-block-align-support', modifyBlockAlignmentSupport );

	/*
	* Function to handle the block alignment icons
	*/

	/**
	 * @function blockAlignIcon
	 *
	 * @description creates svg element based on a given path passed
	 *
	 * @param {*} path
	 *
	 * @returns
	 */
	const blockAlignIcon = ( path ) => {
		return el('svg', { className: 'components-menu-items__item-icon', width: 24, height: 24 },
			el('path', { d: path } )
		);
	};

	/**
	 * @function customBlockAlignmentControls
	 *
	 * @description filter to add custom block alignment toolbar controls
	 */
	const customBlockAlignmentControls = createHigherOrderComponent( ( BlockEdit ) => {
		return ( props ) => {
			const blockName = props.name;
			const currentAlign = props.attributes.align;
			const originalEdit = el( BlockEdit, props );

			// check for block align support
			const blockAlignSupport = getBlockSupport( blockName, 'alignCustom', false );

			// disable specific blocks from having custom alignment support
			if ( excludeBlocksFromCustomAlignmentSupport.includes( blockName ) ) {
				return originalEdit;
			}

			// do not add this custom controls if the block type has no align support
			if ( ! blockAlignSupport ) {
				return originalEdit;
			}

			// combine default WP alignments, justications and custom alignments from theme.json
			const combinedAlignments = [ ...defaultWPAlignments, ...themeJSON.settings._experimentalLayout, ...defaultWPJustifcations ];

			/*
			* Build the toolbar block alignment controls depening on the align support of the block type
			*/

			const allowedAlignControls = [];

			for ( const alignment of combinedAlignments ) {
				let {
					name,
					slug,
					icon,
					width,
					textdomain
				} = alignment;

				// only add the current align control if it's supported. We should always include "none".
				if ( ( defaultWPAlignments.find( alignment => alignment.slug === slug ) || defaultWPJustifcations.find( alignment => alignment.slug === slug ) ) && ! blockAlignSupport.includes( slug ) && slug !== 'none' ) {
					continue;
				}

				// handle creating the
				let controlTitle = width !== false && ! width.includes('%') ? (
					<span className={'components-menu-item__item'}>
						<span className={'components-menu-item__info-wrapper'}>
							<span className={ 'components-menu-item__item'}>{ __( name, textdomain ) }</span>
							<span className={'components-menu-item__info'}>{ 'Max ' + width + ' wide' }</span>
						</span>
					</span>
				) : __( name, textdomain );

				let newControl = {
					title: controlTitle,
					icon: blockAlignIcon( icon ),
					onClick: () => {
						if ( slug === 'none' ) {
							// Because we don't want a "alignnone" classname in our block
							slug = false;
						}

						// Change the block align attribute
						props.setAttributes( {
							align: slug === undefined ? 'none' : slug,
							className: 'align' + slug,
						} );

						// Change the current ToolbarDropdownMenu icon if the block align has been changed
						const alignToolbarButton = document.querySelector('[aria-label="Align"]');

						if ( alignToolbarButton ) {
							alignToolbarButton.innerHTML = '<svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="' + icon + '"/></svg>';
						}
					},
				};

				allowedAlignControls.push( newControl );
			}

			// Get the current ToolbarDropdownMenu icon, depending on the selected align
			let currentIcon = currentAlign ? combinedAlignments.find( alignment => alignment.slug === currentAlign ) : combinedAlignments.find( alignment => alignment.slug === 'none' );
			currentIcon = blockAlignIcon( currentIcon.icon );

			/*
			* Re-Build the block toolbar and edit
			*/

			return el(
				Fragment,
				{},
				el( BlockControls, {
						key: 'controls',
						group: 'default',
					},
					el( ToolbarGroup, null,
						el( ToolbarDropdownMenu, {
							label: 'Align',
							icon: currentIcon,
							controls: allowedAlignControls
						} ),
					),
				),
				el( BlockEdit, props )
			);
		};
	}, 'withInspectorControls' );

	wp.hooks.addFilter( 'editor.BlockEdit', 'tribe/with-inspector-controls', customBlockAlignmentControls );

})();
