@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
  /*  var availableTags = [
      "ActionScript",
      "AppleScript",
      "Asp",
      "BASIC",
      "C",
      "C++",
      "Clojure",
      "COBOL",
      "ColdFusion",
      "Erlang",
      "Fortran",
      "Groovy",
      "Haskell",
      "Java",
      "JavaScript",
      "Lisp",
      "Perl",
      "PHP",
      "Python",
      "Ruby",
      "Scala",
      "Scheme"
    ];
    $( "#country" ).autocomplete({
      source: 'https://restcountries.eu/rest/v2/all'
    });
*/
    $('#country').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://restcountries.eu/rest/v2/name/"+request.term,
            data: { query: request.term },
            success: function (data) {
                var transformed = $.map(data, function (el) {
               
                    return {
                        label: el.name,
                        id: el.alpha3Code,
                        flag: el.flag,
                        capital: el.capital,
                        currency: el.currencies[0].code
                    };
                 
                });
                response(transformed);
            },
            error: function () {
                response([]);
            }
        });
    },
    minLength: 2,
    delay: 100,
    select: function( event, ui ) {
        console.log( ui.item ?
          "Selected: " + ui.item.label :
          "Nothing selected, input was " + this.value);
          $.ajax({ url: `https://free.currencyconverterapi.com/api/v6/convert?q=${ui.item.currency}_INR&compact=ultra&apiKey=bdba4cf7b6eb9daa6f5c`,
                   success: function(data1){
                      var rate = `${data1[`${ui.item.currency}_INR`]}`;
                    $('#selected').html(`Name: ${ui.item.label }<br>Currency: ${ui.item.currency}<br>RAte:${rate } <br>Flag: <img src="${ui.item.flag}">`);

                   } });
      }
});
  } );

  </script>
      <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                  <input type="text" name="country" id="country">
                  <div id="selected">
                  </div>
                
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
