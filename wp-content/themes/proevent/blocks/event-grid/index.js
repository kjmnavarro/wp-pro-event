import { registerBlockType } from '@wordpress/blocks';
import { useSelect } from '@wordpress/data';
import { SelectControl, TextControl } from '@wordpress/components';
import { useState, useEffect } from '@wordpress/element';

import './editor.scss';
import './style.scss';

registerBlockType( 'proevent/event-grid', {
    title: 'Event Grid',
    icon: 'grid-view',
    category: 'widgets',
    attributes: {
        limit: { type: 'number', default: 5 },
        category: { type: 'string', default: '' },
        order: { type: 'string', default: 'ASC' },
    },

    edit: ( props ) => {
        const { attributes, setAttributes } = props;
        const { limit, category, order } = attributes;

        const [ events, setEvents ] = useState( [] );
        const [ categories, setCategories ] = useState( [] );

        useEffect(() => {
            wp.apiFetch({ path: '/wp/v2/event-category?per_page=100' })
                .then( cats => setCategories(cats) )
                .catch( () => setCategories([]) );
        }, []);

        useEffect(() => {
            let apiPath = `/wp/v2/event?per_page=${limit}&orderby=meta_value&order=${order}&meta_key=_event_date`;

            if (category) {
                apiPath += `&event-category=${category}`;
            }

            wp.apiFetch({ path: apiPath })
                .then( posts => setEvents(posts) )
                .catch( () => setEvents([]) );
        }, [limit, category, order]);

        return (
            <div className="proevent-event-grid block-editor-block">
                <SelectControl
                    label="Category"
                    value={ category }
                    options={ [
                        { label: 'All Categories', value: '' },
                        ...categories.map( cat => ({ label: cat.name, value: cat.slug }) ),
                    ] }
                    onChange={ ( value ) => setAttributes({ category: value }) }
                />
                <SelectControl
                    label="Sort Order"
                    value={ order }
                    options={ [
                        { label: 'Ascending', value: 'ASC' },
                        { label: 'Descending', value: 'DESC' },
                    ] }
                    onChange={ ( value ) => setAttributes({ order: value }) }
                />
                <TextControl
                    label="Limit"
                    type="number"
                    value={ limit }
                    onChange={ ( value ) => setAttributes({ limit: parseInt(value) || 5 }) }
                    min={1}
                    max={20}
                />

                <div className="events-grid">
                    {events.length ? (
                        events.map( event => (
                            <article key={ event.id } className="event-card">
                                <h3>{ event.title.rendered }</h3>
                                {/* Date from meta */}
                                <p>Date: { event.meta?._event_date || 'N/A' }</p>
                                <a href={ event.link } className="btn btn-secondary">View Event</a>
                            </article>
                        ))
                    ) : (
                        <p>No events found.</p>
                    )}
                </div>
            </div>
        );
    },

    save: () => {
        return null;
    }
});
