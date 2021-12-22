<?php

/**
 * Accordion Block
 *
 * @package AA_PROJECT
 */

global $aaproject;

use Carbon_Fields\Field;
use Carbon_Fields\Block;

Block::make( __( 'Accordion' ) )
->set_category( 'aa_blocks', __( 'American Accents', $aaproject['context'] ), 'dashicons-home' )
->set_inner_blocks( false )
->add_fields( array(
    Field::make( 'html', 'cmenuhtml' )
    ->set_html( '<h2>Accordion Block</h2>' ),
    Field::make( 'complex', 'accordion', __( '' ) )
    ->set_collapsed( true )
    ->add_fields( array(
        Field::make( 'text', 'accordion_title', 'Accordion Title' ),
        Field::make( 'text', 'accordion_id', 'Accordion ID (must be unique, used to navigate from link, please avoid spaces or special character | ex: printing-characteristics)' ),
        Field::make( 'rich_text', 'acc_content', 'Accordion Content' ),
        Field::make( 'complex', '_acc_child', __( '' ) )
        ->set_collapsed( true )
        ->add_fields( array(
            Field::make( 'text', '_acc_child_title', __('Accordion Title') ),
            Field::make( 'rich_text', '_acc_child_content', __('Accordion Content') )
        ))
        ->set_header_template( 'Accordion Children <%- $_index+1 %>' )
    ))
    ->set_header_template( 'Accordion Parent <%- $_index+1 %>' )
))
->set_render_callback( function( $fields, $attributes, $inner_blocks ) {
    ob_start();
    ?>
    <div class="accordion-module <?php echo $attributes ? $attributes['className'] : ''; ?>">
        <?php foreach( $fields['accordion'] as $pacc ): ?>
            <div class="aa-accordion-module">
                <button class="acc-btn aa-accordion-parent" data-accordion="<?php echo $pacc['_id']; ?>" data-id="<?php echo $pacc['accordion_id'] ?>">
                    <span class="acc-text"><?php echo $pacc['accordion_title']; ?></span>
                    <div class="accordion-indicator">
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="accordion-parent-content" data-accordion-content="<?php echo $pacc['_id']; ?>">
                    <?php if( $pacc['acc_content'] ): ?>
                        <div class="accordion-content">
                            <?php echo $pacc['acc_content']; ?>
                        </div>
                    <?php endif; ?>
                    <?php foreach( $pacc['_acc_child'] as $cacc ): ?>
                        <div class="aa-accordion-child-wrap">
                            <button class="acc-btn aa-accordion-child" data-accordion="<?php echo $cacc['_id']; ?>">
                                <span class="acc-text"><?php echo $cacc['_acc_child_title']; ?></span>
                                <div class="accordion-indicator">
                                    <span></span>
                                    <span></span>
                                </div>
                            </button>
                            <div class="accordion-child-content" data-accordion-content="<?php echo $cacc['_id']; ?>">
                                <?php if( $cacc['_acc_child_content'] ): ?>
                                    <div class="accordion-content">
                                        <?php echo $cacc['_acc_child_content']; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
    $html = ob_get_clean();
    echo $html;
});