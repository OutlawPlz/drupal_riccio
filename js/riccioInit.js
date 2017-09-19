( function ( Drupal ) {

  Drupal.behaviors.riccioInit = {
    attach: function ( context, settings ) {

      var elements = context.querySelectorAll( '[data-riccio-options]' ),
          options;

      for ( var i = elements.length, element; i--, element = elements[ i ]; ) {

        // Get options ID.
        var config = element.getAttribute( 'data-riccio-options' );

        // If options ID exists, create a Riccio instance using given options.
        if ( config ) {
          options = settings[ 'riccio' ][ config ];
          new Riccio( element, options );
        }
      }
    }
  };

} ( Drupal ) );
