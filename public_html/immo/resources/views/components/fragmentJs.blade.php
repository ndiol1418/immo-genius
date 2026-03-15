<script>
    setTimeout(function () {

        fetch("{{ $url }}")

        .then(res => res.text())
        .then(html => {
            $("#{{ $id }}").html(html)
        });

    }, 2000);
</script>
