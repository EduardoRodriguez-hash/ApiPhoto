<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paypal</title>

    <!-- BootStrap 4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-dark">
                <h2 class="text-center text-white">Pago Paypal</h2>
            </div>

            @if(!$error)

            <div class="col-12">


                <div class="card">

                    <div class="card-header bg-white">
                    </div>

                    <div class="card-body">
                        <p class="text-center">Precio:{{$foto->precio}}</p>

                        <form action="{{route('PaypalPago')}}" method="POST">

                            @csrf

                            <input type="hidden" value="{{$foto->precio}}" name="pago" />
                            <input type="hidden" value="{{$foto->id}}" name="id_foto" />
                            <input type="hidden" value="{{$user->id}}" name="user_id" />

                            <button class="btn btn-block btn-warning">
                                Pagar con Paypal
                            </button>

                        </form>

                    </div>
                </div>

            </div>


            @else

            <div class="col-12 text-center mt-5">
                <span>Los datos pasados son invalidos</span>
            </div>

            @endif

        </div>
    </div>

</body>

</html>
