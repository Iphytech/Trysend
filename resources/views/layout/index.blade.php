<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
   <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" <link rel="stylesheet" href="/css/app.css">

    <title>TrySend!</title>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 layout">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
    <!-- Latest compiled and minified JavaScript -->
    
    <script>
        $(document).ready(function(){
            $("#amount").keyup(function(e) {
                // alert('sdfghj');
                var amount = $("#amount").val();
                if(amount < 100 || amount == ""){
                    $("#buttonAmount").attr({'disabled':'disabled'})
                    
                }else $("#buttonAmount").removeAttr("disabled");        
            });

            $("#buttonAmount").click(function(e) {
            // var amount = $("#amount")
            // var modal_amount = $("#modal_amount")
                var amount = $("#amount").val();
                $("#modal_amount").val(amount);
                // modal_amount.val(amount.val())
            });

            $("#recipientaccount").keyup(function() {
                var recipientaccount = $("#recipientaccount").val();
                var destbankcode = $("#accountbank").val();
                var PBFPubKey = 'FLWPUBK-xxxxxxxxxxxxxxxxxxxxxxx-X'
                var token = '<?php echo csrf_token() ?>';

                if (recipientaccount.length === 10) { 

                    $.ajax({
                        
                        type:"POST",
                        url:'https://ravesandbox.azurewebsites.net/flwv3-pug/getpaidx/api/resolve_account',
                        data:{ _token:token, recipientaccount:recipientaccount, destbankcode:destbankcode,PBFPubKey:PBFPubKey},
                        success: function(res) {
                            if(res.data.data.responsecode == 00) {
                                $('#accountname').val(res.data.data.accountname);
                                $("#continue").attr({"disabled":false});
                            } else if (res.data.data.responsecode == 'RN0') {
                                $('#error_msg').text(res.data.data.responsemessage);
                                $('#recipientaccount').addClass('has-error');
                            } else {
                                $('#error_msg').text('There is an issue with your bank number. Please cross-check');
                                $('#recipientaccount').addClass('has-error');
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
