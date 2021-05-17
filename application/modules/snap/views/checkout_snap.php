<html>
<title>Checkout</title>
  <head>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<CLIENT-KEY>"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  </head>
  <body>

    
    <form id="payment-form" method="post" action="<?=site_url()?>/snap/finish">
      <input type="hidden" name="result_type" id="result-type" value=""></div>
      <input type="hidden" name="result_data" id="result-data" value=""></div>
    </form>
    
    <form>
      item id :
      <input type="text" id="id" name="id" value="a1">
      price :
      <input type="text" id="price" name="price" value="10000">
      quantity :
      <input type="text" id="quantity" name="quantity" value="1">
      Nama Barang :
      <input type="text" id="name" name="name" value="apple">
      Total :
      <input type="text" id="gross_amount" name="gross_amount" value="10000">
      <button id="pay-button">Bayar</button>
    </form>


    <button type="submit" id="clik">clik me</button>

    <script type="text/javascript">

    $('#clik').click(function (e) {
      e.preventDefault();
      let arr = [
        {id: "2", price: "7200000", quantity: "1", name: "ASUS ZENBOOK"},
        {id: "7", price: "6300000", quantity: "1", name: "LENOVO IDEAPAD"},
        {id: "a3", price: "4000", quantity: "1", name: "Ongkir"}
      ];
      
      console.log(arr);

      $.ajax({
				type: 'POST',
				url: '<?= site_url() ?>snap/detail',
        data: {produk: arr},
        cache: false,

      success: function(data) {
        //location = data;

        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
      });
    })

    $('#pay-button').click(function (event) {
      event.preventDefault();
      $(this).attr("disabled", "disabled");
      
      var id            = $("#idk").val();
      var price         = $("#price").val();
      var quantity      = $("#quantity").val();
      var name          = $("#name").val();
      var gross_amount  = $("#gross_amount").val();

    $.ajax({
      method : 'POST',
      url: '<?=site_url()?>snap/token',
      data : {id: id, price: price, quantity: quantity, name: name, gross_amount: gross_amount},
      cache: false,

      success: function(data) {
        //location = data;

        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });
  });

  </script>


</body>
</html>