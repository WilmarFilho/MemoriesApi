<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Memories Api Documentação</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Poppins;
        }

        body,
        main,
        html {
            background-color: black;
            color: white;
        }

        .params {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 1em;
            align-items: center;
            margin: 1em 0;
        }


        .container {
            width: 75%;
            padding: 5em 0;
        }

        div.alert {
            font-size: 1em;
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 90%;
            }

            div.alert {
                font-size: 1em;
            }
        }

        @media screen and (max-width: 480px) {
            .container {
                width: 80%;
            }

            div.alert {
                font-size: 0.7em;
                padding: 1rem 0.5rem;
            }

        }
    </style>

</head>

<body>

    <main class="container">
        <section>
            <h2 class="mb-5 text-center">Rotas para Autenticação [POST]</h2>

            <div class="alert alert-success" role="alert">
                https://apiMemories.celleta.com/api/register
            </div>

            <div class="params">
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {NAME : STRING}
                </button>
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {EMAIL : EMAIL}
                </button>
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {PASSWORD : STRING|MIN:6}
                </button>

            </div>

            <div class="alert alert-success" role="alert">
                https://apiMemories.celleta.com/api/login
            </div>

            <div class="params">

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {EMAIL : EMAIL}
                </button>
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {PASSWORD : STRING|MIN:6}
                </button>

            </div>

            <div class="alert alert-success" role="alert">
                https://apiMemories.celleta.com/api/logout
            </div>

            <div class="params mb-5">

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {BEARER TOKEN}
                </button>



            </div>


            <h2 class="mb-5 text-center">Rotas para Autenticação [GET]</h2>

            <div class="alert alert-primary" role="alert">
                https://apiMemories.celleta.com/api/user
            </div>

            <div class="params">
                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {BEARER TOKEN}
                </button>

            </div>




            <h2 class="mb-5  text-center">Rotas para Pages [POST]</h2>

            <div class="alert alert-success" role="alert">
                https://apiMemories.celleta.com/api/bebida/page/novo
            </div>

            <div class="params mb-5">

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {IMG_01 : JPEG|PNG|JPG }
                </button>

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {IMG_02 : JPEG|PNG|JPG }
                </button>

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {IMG_03 : JPEG|PNG|JPG }
                </button>

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {DESCRICAO : STRING}
                </button>

                <button type="button" class="btn btn-secondary" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-placement="top" data-bs-content="Top popover">
                    {BEARER TOKEN}
                </button>

                

            </div>


            <h2 class="mb-5  text-center">Rotas para Pages [GET]</h2>

            <div class="alert alert-primary" role="alert">
                https://apiMemories.celleta.com/api/bebida/pages/{hash_id}
            </div>



        </section>

    </main>

</body>

</html>