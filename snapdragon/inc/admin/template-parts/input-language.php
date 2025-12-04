<section class="grid grid-cols-12">    
<div class="grid grid-cols-12 col-span-12">
        <label class="input-group-label" for="language-input-<?php esc_attr_e( $args['language']->code ) ?>">
            <img class="size-10 rounded-full drop-shadow-sm drop-shadow-black/30" src="<?php echo esc_url( $args['language']->attached_image ) ?>" alt="<?php esc_attr_e( $args['language']->title ) ?>">
            <?php esc_html_e( $args['language']->title ) ?>
        </label>
        <div class="col-span-7 self-center toggle-button-group group">
            <label for="language-input-<?php esc_attr_e( $args['language']->code ) ?>" >
                <span class="thumb"></span>
                <input type="checkbox" name="<?php esc_attr_e( $args['language']->code ) ?>" id="language-input-<?php esc_attr_e( $args['language']->code ) ?>" value="<?php esc_attr_e( $args['language']->code ) ?>" <?php esc_attr_e( $args['checked'] === true ? 'checked' : '' ) ?>>
            </label>
        </div>
    </div>
    <hr class="my-4 h-0.5 border-t-0 bg-neutral-50 col-span-6" />
</section>