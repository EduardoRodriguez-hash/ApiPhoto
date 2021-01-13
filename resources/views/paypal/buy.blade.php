<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paypal</title>

    <!-- CSS -->
    <link rel="stylesheet" href="{{asset('./css/styles.css')}}" />

    <!-- BootStrap 4 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Bootstrap 4 JQUERY -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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

                        <div class="pos-rel img-tam mx-auto">
                            <img src="{{route('getImagePhoto',['filename'=>$foto->filename])}}" alt="No se pudo cargar la images" class="img-fluid rounded border opacity" id="NotDowload" . />
                            <h2 class="p-abs text-white text-center">Comprar Foto</h2>
                        </div>

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

    <script src="{{asset('./js/all.js')}}"></script>

</body>

</html>
