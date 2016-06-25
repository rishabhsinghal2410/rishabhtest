var bindReadMore = function(){
    $('.read-more').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parent();
        parent.trigger("destroy");
        parent.removeClass('truncable-txt--is-truncated');
        parent.addClass('truncable-txt--is-not-truncated');
        bindReadLess(); // bind click on "less"
    });
};

var bindReadLess = function(){
    $('.read-less').on('click', function(e) {
        e.preventDefault();
        var parent = $(this).parent();
        truncateIfNeeded(parent); // Re-initialize ellipsis
    });
};

var truncateIfNeeded = function(jqueryTag){
    var $selectionToTruncate = jqueryTag || $('.truncable-txt');
    
    $selectionToTruncate.dotdotdot({
        ellipsis: '...',
        watch   : true,
        wrap    : 'letter',
        height  : 20 * 8, // max number of lines
        after   : '.read-more',
        callback: function( isTruncated, orgContent ) {
            var $currentReadMore = $(this).find('.read-more');
            var $currentReadLess = $(this).find('.read-less');
            
            if( isTruncated ){
                $(this).addClass('truncable-txt--is-truncated');
            }
            bindReadMore(); // bind click on "read more"
        },
    });
};

$(function() {
    truncateIfNeeded(); // Initialize ellipsis
});