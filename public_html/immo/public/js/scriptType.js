$(function() {
    $('body').on('click', '.editModal', function() {
        $('#form').attr('action', $(this).attr('href'));
        document.getElementsByName('_method')[0].value = 'PATCH'
        $('#id').val($(this).data('id'));
        $('#name').val($(this).data('name'));

    });
});