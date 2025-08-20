import { registerBlockType } from '@wordpress/blocks';
import { QueryLoop } from '@wordpress/block-editor';

registerBlockType('proevent/event-grid', {
  title: 'Event Grid',
  icon: 'calendar',
  category: 'layout',
  edit: () => (
    <QueryLoop query={{ postType: 'event' }}>
      <div className="event-grid">
        <InnerBlocks />
      </div>
    </QueryLoop>
  ),
  save: () => {
    return (
      <div className="event-grid">
        {/* Dynamic Event Grid Rendering */}
      </div>
    );
  },
});
