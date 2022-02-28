$('form').submit(function(e)
{  
    $(this).find("button[type='submit']").prop('disabled',true);
});

$('form').change(function(e)
{  
    $(this).find("button[type='submit']").attr('disabled',false);
});