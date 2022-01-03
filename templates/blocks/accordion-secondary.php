<?php

/**
 * Accordion Secondary Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Accordion Secondary' ) )
->set_category( 'aa_blocks', __( 'American Accents', $aaproject['context'] ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>Accordion Secondary Block</h2>' ),
    Field::make( 'complex', 'accordion_secondary', __( '' ) )
    ->set_collapsed( true )
    ->add_fields( array(
        Field::make( 'text', 'accordion_secondary_title', 'Accordion Title' ),
        Field::make( 'text', 'accordion_secondary_id', 'Accordion ID (must be unique, used to navigate from link, please avoid spaces or special character | ex: printing-characteristics)' ),
        Field::make( 'rich_text', 'acc_secondary_content', 'Accordion Content' ),
    ))
    ->set_header_template( 'Accordion Secondary <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ob_start();
    ?>
    <div class="accordion-module <?php echo $attributes ? $attributes['className'] : ''; ?>">
        <?php foreach( $fields['accordion_secondary'] as $pacc ): ?>
            <div class="aa-accordion-module">
                <button class="acc-btn aa-accordion-child" data-accordion="<?php echo $pacc['_id']; ?>" data-id="<?php echo $pacc['accordion_secondary_id'] ?>">
                    <span class="acc-text"><?php echo $pacc['accordion_secondary_title']; ?></span>
                    <div class="accordion-indicator">
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="accordion-child-content" data-accordion-content="<?php echo $pacc['_id']; ?>">
                    <?php if( $pacc['acc_secondary_content'] ): ?>
                        <div class="accordion-content">
                            <?php echo $pacc['acc_secondary_content']; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    $html = ob_get_clean();
    echo apply_filters('the_content', $html);
});