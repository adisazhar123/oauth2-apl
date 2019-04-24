<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oauth Clients</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .client:hover {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Oauth Server</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Home </a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/oauth/newclient">Go to Oauth Server to Register Client <span class="sr-only">(current)</span></a>
                </li>                                
                </ul>                
            </div>
        </div>        
    </nav>
    
    <br>

    <section class="body">
        <div class="container">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>Clients Registered to TCBook Oauth</h3>
                    </div>
                    <div class="card-body clients">
                          <h1></h1>
                        <form action="newclient/store" method="POST">
                            <button class="btn btn-primary" type="submit">Add More</button>
                        </form>

                        <h5>My registered cliets:</h5>
                        {% for client in clients %}
                            <div class="client">
                                <p>Client ID: {{ client.client_id }} <br>
                                Client Secret: {{ client.client_secret }}</p>
                            </div>
                        {% endfor  %}
                    </div>                    
                </div>            
        </div>
    </section>




    
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>
</html>