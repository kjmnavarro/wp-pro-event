import { registerBlockType } from '@wordpress/blocks';
import { MediaUpload, MediaUploadCheck, RichText, URLInputButton } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import { useState } from '@wordpress/element';

import './editor.scss';
import './style.scss';

registerBlockType( 'proevent/hero-cta', {
    title: 'Hero with CTA',
    icon: 'cover-image',
    category: 'layout',
    attributes: {
        imageUrl: { type: 'string', default: '' },
        imageId: { type: 'number' },
        heading: { type: 'string', source: 'html', selector: 'h2' },
        buttonText: { type: 'string', default: 'Learn More' },
        buttonUrl: { type: 'string', default: '' },
    },
    edit: ( props ) => {
        const { attributes, setAttributes } = props;
        const { imageUrl, imageId, heading, buttonText, buttonUrl } = attributes;

        const onSelectImage = ( media ) => {
            setAttributes({
                imageUrl: media.url,
                imageId: media.id,
            });
        };

        return (
            <div className="proevent-hero-cta block-editor-block">
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={ onSelectImage }
                        allowedTypes={ [ 'image' ] }
                        value={ imageId }
                        render={ ( { open } ) => (
                            <Button onClick={ open } className={ !imageUrl ? 'button button-large' : 'image-button' }>
                                { !imageUrl ? 'Upload Image' : <img src={ imageUrl } alt="Hero Image" /> }
                            </Button>
                        ) }
                    />
                </MediaUploadCheck>
                <RichText
                    tagName="h2"
                    placeholder="Write your heading..."
                    value={ heading }
                    onChange={ ( value ) => setAttributes( { heading: value } ) }
                />
                <div className="button-wrapper">
                    <RichText
                        tagName="span"
                        placeholder="Button Text"
                        value={ buttonText }
                        onChange={ ( value ) => setAttributes( { buttonText: value } ) }
                    />
                    <URLInputButton
                        url={ buttonUrl }
                        onChange={ ( url, post ) => setAttributes( { buttonUrl: url } ) }
                    />
                </div>
            </div>
        );
    },
    save: ( props ) => {
        const { attributes } = props;
        const { imageUrl, heading, buttonText, buttonUrl } = attributes;

        return (
            <div className="proevent-hero-cta">
                { imageUrl && <img src={ imageUrl } alt={ heading || 'Hero Image' } loading="lazy" /> }
                { heading && <h2>{ heading }</h2> }
                { buttonUrl && buttonText && (
                    <a href={ buttonUrl } className="btn btn-primary">
                        { buttonText }
                    </a>
                ) }
            </div>
        );
    },
} );
