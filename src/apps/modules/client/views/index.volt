<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/oauth/newclient">Go to Oauth Server to Register Client</a>
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
                        <h3>My friends from TCBook</h3>
                    </div>
                    <div class="card-body friends">
                        <p>Loading ...</p>
                    </div>                    
                </div>            
        </div>
    </section>

    <input type="hidden" id="base_url" name="base_url" value="{{  url('') }}">



    
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
$(function(){
    const BASE_URL = $("#base_url").val();        
    console.log("PP")

    async function getFriends() {
        let friends_res;
        try {
            friends_res = await $.ajax({
                url: `client/resource`,
                method: 'GET',
                // dataType: "jsonp",
            }); 

        } catch(err) {
            alert("Unauthorized");
            const html = `<h5 class="card-title">Please Login using TCBook to get your friend list</h5>
                        <p class="card-text">Clicking the Login button bellow will send you to TCBook Oauth server.</p>
                        <a href="/oauth/authorize?response_type=code&client_id={{ oauth_client.client_id }}&state=haloguys" class="btn btn-primary">Login</a>`;
            $(".friends").html(html);
            console.log(err);
            return;
        }
        let html = '';
        friends_res.friends.map((el, idx) => {
            html += `<p>${el}</p>`;
        });

        $(".friends").html(html);

        console.log(friends_res);
    }

     getFriends();


});
    

</script>

</body>
</html>