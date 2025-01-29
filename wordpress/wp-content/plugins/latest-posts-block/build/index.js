import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, RangeControl } from '@wordpress/components';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';

const Edit = (props) => {
    const { attributes, setAttributes } = props;
    const { numberOfPosts } = attributes;

    const posts = useSelect((select) => {
        return select('core').getEntityRecords('postType', 'post', {
            per_page: numberOfPosts,
            _embed: true,
        });
    }, [numberOfPosts]);

    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <InspectorControls>
                <PanelBody title={__('Settings')}>
                    <RangeControl
                        label={__('Number of Posts')}
                        value={numberOfPosts}
                        onChange={(value) => setAttributes({ numberOfPosts: value })}
                        min={1}
                        max={10}
                    />
                </PanelBody>
            </InspectorControls>
            {!posts && <p>{__('Loading...')}</p>}
            {posts && posts.length === 0 && <p>{__('No posts found.')}</p>}
            {posts && posts.length > 0 && (
                <div className="latest-posts-block">
                    {posts.map((post) => (
                        <div key={post.id} className="latest-post">
                            {post._embedded['wp:featuredmedia'] && (
                                <img
                                    src={post._embedded['wp:featuredmedia'][0].source_url}
                                    alt={post.title.rendered}
                                />
                            )}
                            <h3>{post.title.rendered}</h3>
                            <p>{post.excerpt.rendered}</p>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
};

registerBlockType('latest-posts-block/main', {
    title: __('Latest Posts Block'),
    icon: 'admin-post',
    category: 'widgets',
    attributes: {
        numberOfPosts: {
            type: 'number',
            default: 5,
        },
    },
    edit: Edit,
    save: () => null, // Server-side rendering
});

