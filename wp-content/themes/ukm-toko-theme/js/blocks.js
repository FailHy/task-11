/**
 * Gutenberg Custom Blocks Client Registration
 * Registers Hero Banner, Product Grid, and Testimonial Slider for the Block Editor.
 */
(function (wp) {
    if (!wp || !wp.blocks || !wp.element) return;

    var el = wp.element.createElement;
    var Fragment = wp.element.Fragment;
    var registerBlockType = wp.blocks.registerBlockType;
    var ServerSideRender = wp.serverSideRender || (wp.components && wp.components.ServerSideRender);
    var InspectorControls = wp.blockEditor ? wp.blockEditor.InspectorControls : wp.editor.InspectorControls;
    var PanelBody = wp.components ? wp.components.PanelBody : null;
    var TextControl = wp.components ? wp.components.TextControl : null;
    var RangeControl = wp.components ? wp.components.RangeControl : null;

    // 1. Hero Banner Block (Requirement 28)
    registerBlockType('ukm/hero-banner', {
        title: 'Hero Banner (UKM)',
        icon: 'cover-image',
        category: 'design',
        keywords: ['hero', 'banner', 'sembako', 'ukm'],
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var inspector = InspectorControls && PanelBody && TextControl ? el(
                InspectorControls,
                {},
                el(
                    PanelBody,
                    { title: 'Pengaturan Hero Banner', initialOpen: true },
                    el(TextControl, {
                        label: 'Judul Utama (Title)',
                        value: attributes.title || '',
                        onChange: function (val) { setAttributes({ title: val }); }
                    }),
                    el(TextControl, {
                        label: 'Sub-judul (Subtitle)',
                        value: attributes.subtitle || '',
                        onChange: function (val) { setAttributes({ subtitle: val }); }
                    }),
                    el(TextControl, {
                        label: 'Teks Tombol (CTA Text)',
                        value: attributes.ctaText || '',
                        onChange: function (val) { setAttributes({ ctaText: val }); }
                    }),
                    el(TextControl, {
                        label: 'Link Tombol (CTA URL)',
                        value: attributes.ctaUrl || '',
                        onChange: function (val) { setAttributes({ ctaUrl: val }); }
                    }),
                    el(TextControl, {
                        label: 'URL Gambar Latar (Background Image)',
                        value: attributes.bgImage || '',
                        onChange: function (val) { setAttributes({ bgImage: val }); }
                    })
                )
            ) : null;

            var preview = ServerSideRender ? el(ServerSideRender, {
                block: 'ukm/hero-banner',
                attributes: attributes
            }) : el('div', { style: { padding: '20px', background: '#0f172a', color: '#fff', textAlign: 'center' } }, attributes.title || 'Hero Banner (UKM)');

            return el(Fragment, {}, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });

    // 2. Product Grid Block (Requirement 29)
    registerBlockType('ukm/product-grid', {
        title: 'Product Grid (UKM)',
        icon: 'cart',
        category: 'design',
        keywords: ['produk', 'grid', 'shop', 'ukm'],
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var inspector = InspectorControls && PanelBody ? el(
                InspectorControls,
                {},
                el(
                    PanelBody,
                    { title: 'Pengaturan Product Grid', initialOpen: true },
                    TextControl ? el(TextControl, {
                        label: 'Judul Grid',
                        value: attributes.title || '',
                        onChange: function (val) { setAttributes({ title: val }); }
                    }) : null,
                    RangeControl ? el(RangeControl, {
                        label: 'Jumlah Produk Ditampilkan',
                        value: attributes.postsPerPage || 4,
                        min: 1,
                        max: 12,
                        onChange: function (val) { setAttributes({ postsPerPage: val }); }
                    }) : null,
                    TextControl ? el(TextControl, {
                        label: 'Slug Kategori (Opsional)',
                        value: attributes.category || '',
                        onChange: function (val) { setAttributes({ category: val }); }
                    }) : null
                )
            ) : null;

            var preview = ServerSideRender ? el(ServerSideRender, {
                block: 'ukm/product-grid',
                attributes: attributes
            }) : el('div', { style: { padding: '20px', border: '1px dashed #ccc' } }, attributes.title || 'Product Grid (UKM)');

            return el(Fragment, {}, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });

    // 3. Testimonial Slider Block (Requirement 30)
    registerBlockType('ukm/testimonial-slider', {
        title: 'Testimonial Slider (UKM)',
        icon: 'businessman',
        category: 'design',
        keywords: ['klien', 'testimonial', 'slider', 'ukm'],
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;

            var inspector = InspectorControls && PanelBody ? el(
                InspectorControls,
                {},
                el(
                    PanelBody,
                    { title: 'Pengaturan Testimonial Slider', initialOpen: true },
                    TextControl ? el(TextControl, {
                        label: 'Judul Seksi Testimoni',
                        value: attributes.title || '',
                        onChange: function (val) { setAttributes({ title: val }); }
                    }) : null,
                    RangeControl ? el(RangeControl, {
                        label: 'Jumlah Testimoni CPT Klien',
                        value: attributes.postsPerPage || 3,
                        min: 1,
                        max: 10,
                        onChange: function (val) { setAttributes({ postsPerPage: val }); }
                    }) : null
                )
            ) : null;

            var preview = ServerSideRender ? el(ServerSideRender, {
                block: 'ukm/testimonial-slider',
                attributes: attributes
            }) : el('div', { style: { padding: '20px', border: '1px dashed #ccc' } }, attributes.title || 'Testimonial Slider (UKM)');

            return el(Fragment, {}, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });
})(window.wp);
