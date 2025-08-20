import { registerBlockType } from '@wordpress/blocks';
import { MediaUpload, InnerBlocks, InspectorControls } from '@wordpress/block-editor';
import { Button, PanelBody, TextControl } from '@wordpress/components';
import { useState } from '@wordpress/element';

registerBlockType('proevent/hero-cta', {
  title: 'Hero with CTA',
  icon: 'format-image',
  category: 'layout',
  attributes: {
    imageUrl: {
      type: 'string',
      default: '',
    },
    heading: {
      type: 'string',
      default: 'Your Heading Here',
    },
    buttonText: {
      type: 'string',
      default: 'Learn More',
    },
    buttonUrl: {
      type: 'string',
      default: '#',
    },
  },
  edit: (props) => {
    const { attributes, setAttributes } = props;

    const handleImageSelect = (media) => {
      setAttributes({
        imageUrl: media.url,
      });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title="Settings" initialOpen={true}>
            <TextControl
              label="Heading"
              value={attributes.heading}
              onChange={(heading) => setAttributes({ heading })}
            />
            <TextControl
              label="Button Text"
              value={attributes.buttonText}
              onChange={(buttonText) => setAttributes({ buttonText })}
            />
            <TextControl
              label="Button URL"
              value={attributes.buttonUrl}
              onChange={(buttonUrl) => setAttributes({ buttonUrl })}
            />
          </PanelBody>
        </InspectorControls>

        <div className="hero-cta-block">
          <MediaUpload
            onSelect={handleImageSelect}
            allowedTypes="image"
            value={attributes.imageUrl}
            render={({ open }) => (
              <Button onClick={open}>Select Hero Image</Button>
            )}
          />
          <div>
            <h2>{attributes.heading}</h2>
            <a href={attributes.buttonUrl} className="cta-button">
              {attributes.buttonText}
            </a>
          </div>
        </div>
      </>
    );
  },
  save: (props) => {
    const { attributes } = props;

    return (
      <section className="hero-cta" style={{ backgroundImage: `url(${attributes.imageUrl})` }}>
        <h2>{attributes.heading}</h2>
        <a href={attributes.buttonUrl} className="cta-button">
          {attributes.buttonText}
        </a>
      </section>
    );
  },
});
