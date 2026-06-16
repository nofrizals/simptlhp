<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Credentials Checking...</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
</head>

<body class="container">
    <div class="container-fluid px-1 px-md-5 py-5 mx-auto">
        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10 col-lg-6 text-center">
                <img src="{{ asset('assets/images/ilustrasi/security-animate.svg') }}" alt="security">
                <div class="dot"></div>
                <h1 style="color:#455A64" id="msg">
                    <span class="loading">memeriksa</span>
                </h1>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/template/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        $(function() {
            setTimeout(check, 1000);
        });

        function check() {
            $.ajax({
                url: '{{ url('egov-checking') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    token: '{{ $token }}'
                },
                success: function(res) {
                    if (res.message) {
                        $('.dot').addClass('d-none');
                        $('#msg').html(res.message);
                    } else if (res.data) {
                        $('#msg').html("<span class='loading'>mengalihkan</span>");
                        // TODO: tambahkan redirect jika ada target URL
                        // window.location.href = '{{ url('/dashboard') }}';
                    }
                },
                error: function() {
                    $('.dot').addClass('d-none');
                    $('#msg').html('Gagal membuat koneksi ke server eGov');
                }
            });
        }
    </script>
</body>

</html>
