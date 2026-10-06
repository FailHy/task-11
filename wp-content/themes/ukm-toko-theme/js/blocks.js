/**
 * Gutenberg Custom Blocks Client Registration
 * Registers Hero Banner, Product Grid, and Testimonial Slider for the Block Editor.
 */
(function (wp) {
    if (!wp || !wp.blocks || !wp.element) return;

    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var useBlockProps = wp.blockEditor && wp.blockEditor.useBlockProps ? wp.blockEditor.useBlockProps : function (p) { return p || {}; };
    var ServerSideRender = wp.serverSideRender || (wp.components && wp.components.ServerSideRender);
    var InspectorControls = wp.blockEditor ? wp.blockEditor.InspectorControls : (wp.editor ? wp.editor.InspectorControls : null);
    var PanelBody = wp.components ? wp.components.PanelBody : null;
    var TextControl = wp.components ? wp.components.TextControl : null;
    var RangeControl = wp.components ? wp.components.RangeControl : null;

    // 1. Hero Banner Block (Requirement 28)
    registerBlockType('ukm/hero-banner', {
        apiVersion: 2,
        title: 'Hero Banner (UKM)',
        icon: 'cover-image',
        category: 'design',
        keywords: ['hero', 'banner', 'sembako', 'ukm'],
        attributes: {
            title: {
                type: 'string',
                default: 'Selamat Datang di UKM Toko Sembako'
            },
            subtitle: {
                type: 'string',
                default: 'Sedia Kebutuhan Pokok & Sembako Murah, Lengkap, dan Terpercaya.'
            },
            ctaText: {
                type: 'string',
                default: 'Mulai Belanja'
            },
            ctaUrl: {
                type: 'string',
                default: '/shop'
            },
            bgImage: {
                type: 'string',
                default: ''
            }
        },
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps({
                className: 'ukm-block-editor-hero',
                style: { cursor: 'pointer', position: 'relative' }
            });

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

            var preview = ServerSideRender ? el(
                'div',
                { style: { pointerEvents: 'none' } },
                el(ServerSideRender, {
                    block: 'ukm/hero-banner',
                    attributes: attributes
                })
            ) : el('div', {
                style: {
                    background: '#0f172a',
                    color: '#ffffff',
                    padding: '3rem 1.5rem',
                    textAlign: 'center',
                    borderRadius: '8px'
                }
            },
                el('h2', { style: { fontSize: '1.8rem', margin: '0 0 10px', color: '#fff' } }, attributes.title || 'Hero Banner (UKM)'),
                el('p', { style: { color: '#cbd5e1', margin: '0 0 15px' } }, attributes.subtitle || ''),
                el('span', { style: { display: 'inline-block', background: '#0284c7', color: '#fff', padding: '10px 20px', borderRadius: '4px', fontWeight: 'bold' } }, attributes.ctaText || 'Mulai Belanja')
            );

            return el('div', blockProps, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });

    // 2. Product Grid Block (Requirement 29)
    registerBlockType('ukm/product-grid', {
        apiVersion: 2,
        title: 'Product Grid (UKM)',
        icon: 'cart',
        category: 'design',
        keywords: ['produk', 'grid', 'shop', 'ukm'],
        attributes: {
            postsPerPage: {
                type: 'number',
                default: 4
            },
            title: {
                type: 'string',
                default: 'Produk Unggulan'
            },
            category: {
                type: 'string',
                default: ''
            }
        },
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps({
                className: 'ukm-block-editor-product-grid',
                style: { cursor: 'pointer', position: 'relative' }
            });

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

            var preview = ServerSideRender ? el(
                'div',
                { style: { pointerEvents: 'none' } },
                el(ServerSideRender, {
                    block: 'ukm/product-grid',
                    attributes: attributes
                })
            ) : el('div', { style: { padding: '20px', border: '1px dashed #cbd5e1', borderRadius: '6px' } }, attributes.title || 'Product Grid');

            return el('div', blockProps, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });

    // 3. Testimonial Slider Block (Requirement 30)
    registerBlockType('ukm/testimonial-slider', {
        apiVersion: 2,
        title: 'Testimonial Slider (UKM)',
        icon: 'businessman',
        category: 'design',
        keywords: ['klien', 'testimonial', 'slider', 'ukm'],
        attributes: {
            title: {
                type: 'string',
                default: 'Apa Kata Mitra & Pelanggan Kami'
            },
            postsPerPage: {
                type: 'number',
                default: 3
            }
        },
        supports: { html: false },
        edit: function (props) {
            var attributes = props.attributes;
            var setAttributes = props.setAttributes;
            var blockProps = useBlockProps({
                className: 'ukm-block-editor-testimonial',
                style: { cursor: 'pointer', position: 'relative' }
            });

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

            var preview = ServerSideRender ? el(
                'div',
                { style: { pointerEvents: 'none' } },
                el(ServerSideRender, {
                    block: 'ukm/testimonial-slider',
                    attributes: attributes
                })
            ) : el('div', { style: { padding: '20px', border: '1px dashed #cbd5e1', borderRadius: '6px' } }, attributes.title || 'Testimonial Slider');

            return el('div', blockProps, inspector, preview);
        },
        save: function () {
            return null; // dynamic block render in PHP
        }
    });
})(window.wp);
