/**
 * BLOCK: blocks
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const {
	RichText,
} = wp.editor;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @link https://wordpress.org/gutenberg/handbook/block-api/
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'gutenberg-extra/callout', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Callout', 'gutenberg-extra' ), // Block title.
	description: __( 'Disaply a small but important chunk of information to call attention.', 'gutenberg-extra' ),
	icon: 'format-status', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'gutenberg-extra', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Callout', 'gutenberg-extra' ),
	],
	attributes: {
		title: {
			type: 'array',
			source: 'children',
			selector: 'h2',
		},
		content: {
			type: 'array',
			source: 'children',
			selector: 'p',
		}
	},

	styles: [
		{ name: 'blue', label: __( 'Blue', 'gutenberg-extra' ), isDefault: true },
		{ name: 'green', label: __( 'Green', 'gutenberg-extra' ) },
		{ name: 'red', label: __( 'Red', 'gutenberg-extra' ) },
		{ name: 'grey', label: __( 'Grey', 'gutenberg-extra' ) },
		{ name: 'yello', label: __( 'Yello', 'gutenberg-extra' ) },
	],

	/**
	 * The edit function describes the structure of your block in the context of the editor.
	 * This represents what the editor will render when the block is used.
	 *
	 * The "edit" property must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	edit: ( props ) => {
		const {
			className,
			attributes: {
				title,
				content,
			},
			setAttributes
		} = props;

		const onChangeTitle = ( value ) => {
			setAttributes( { title: value } );
		};

		const onChangeContent = ( newContent ) => {
			setAttributes( { content: newContent } );
		};

		// console.log(props);

		return (
			<section className={ props.className }>
				<RichText
					tagName="h2"
					placeholder={ __( 'Callout title...', 'gutenberg-extra' ) }
					value={ title }
					onChange={ onChangeTitle }
				/>

				<RichText
					tagName="p"
					placeholder={ __( 'Callout description...', 'gutenberg-extra' ) }
					onChange={ onChangeContent }
					value={ content }
				/>
			</section>
		);
	},

	/**
	 * The save function defines the way in which the different attributes should be combined
	 * into the final markup, which is then serialized by Gutenberg into post_content.
	 *
	 * The "save" property must be specified and must be a valid function.
	 *
	 * @link https://wordpress.org/gutenberg/handbook/block-api/block-edit-save/
	 */
	save: function( props ) {
		const {
			className,
			attributes: {
				title,
				content,
			},
		} = props;

		return (
			<section className={ className }>
				<RichText.Content tagName="h2" value={ title } />
				<RichText.Content tagName="p" value={ content } />
			</section>
		);
	},
} );
