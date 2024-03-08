<form method="POST" action="walkin_order.php"  enctype="multipart/form-data">
    <div class="form-floating mb-2">
        <select class="form-control rounded-3" id="productCategory" name="product_category" onchange="handleWalkin(event)">
            <option value=""></option>
            <option value="baby-and-kids">Baby and Kids</option>
            <option value="beauty-care">Beauty Care</option>
            <option value="health-care">Health Care</option>
            <option value="personal-care">Personal Care</option>
        </select>
        <label for="productCategory">Product Category</label>
    </div>
    <div class="form-floating mb-2">
        <select class="form-control rounded-3" id="productName" name="product_name" onchange="handleProduct(event)">
        </select>
        <label for="productName">Product/Brand Name</label>
    </div>

    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="price" placeholder="" name="price" disabled>
        <label for="price">Price</label>
    </div>
    <div class="form-floating mb-2">
        <input type="number" class="form-control rounded-3" id="quantity" placeholder="" name="quantity">
        <label for="quantity">Quantity</label>
    </div>
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Buy</button>
</form>
<script>
    let products = <?php echo json_encode($product); ?> ;
    function handleWalkin(event){
        // console.log(event)
        let product_category = null
        // product_category = document.getElementsByName('product_category')[0].value
        product_category = event.target.value
        
        // console.log(products,product_category);
        // document.getElementsByName('product_category').innerHTML = '';
        let selectElement = document.getElementById("productName");
        selectElement.options.length = 0;
        if(product_category != null){
            console.log(products,product_category,products[product_category])
            // products[product_category].forEach((data,index) => {
            //     addOption(index,index)
            // });
            addOption('','')
            for (let index in products[product_category]) {
                addOption(index,index)
            }
        }
        document.getElementById("price").value = "";
        document.getElementById("quantity").max = "";
    }
    function addOption(value, text) {
        var select = document.getElementById("productName");
        var option = document.createElement("option");
        option.value = value;
        option.text = text;
        select.appendChild(option);
    }

    function handleProduct(event){
        console.log(products['health-care'][event.target.value])
        let select = document.getElementById("productCategory").value;
        console.log(select)
        let value = event.target.value
        let obj = products[select][value]
        console.log(event.target.value,select,products)
        console.log(products[select][value])
        document.getElementById("price").value = obj.price;
        document.getElementById("quantity").max = obj.quantity;
    }

    // Example usage
    // addOption("value1", "Option 1");
</script>
