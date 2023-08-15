$(function() {
    let $autocomplete = $('#auto-complete');
    
    $autocomplete.autocomplete({
        source: "autoComplete.php",
        minLength: 1,
        select: function(event, ui) { 
            $autocomplete.attr('name', 'id').val(ui.item.id);
            $("#search-form").submit();
        }
    });

    $("#search-form").on("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });
});
