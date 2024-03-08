<form method="POST" action="insert_product.php"  enctype="multipart/form-data">
    <div class="form-floating mb-2">
        <select class="form-control rounded-3" id="newProductCategory" name="product_category" onchange="handleNewProduct(event)">
            <option value=""></option>
            <option value="baby-and-kids">Baby and Kids</option>
            <option value="beauty-care">Beauty Care</option>
            <option value="health-care">Health Care</option>
            <option value="personal-care">Personal Care</option>
        </select>
        <label for="newProductCategory">Product Category</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="new_product_name" placeholder="" name="product_name" >
        <label for="new_product_name">Product/Brand Name</label>
    </div>

    <div class="form-floating mb-2 d-none" id="genericHolder">
        <input type="text" class="form-control rounded-3" id="genericName" placeholder="" name="genericName" >
        <label for="genericName">Generic Name</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="newDescription" placeholder="" name="description" >
        <label for="newDescription">Description</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="newImgUrl" placeholder="" name="imageUrl" >
        <label for="newImgUrl">Image URL</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="original_price" placeholder="" name="original_price">
        <label for="original_price">Original Price</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="price" placeholder="" name="price">
        <label for="price">New Price</label>
    </div>
    <div class="form-floating mb-2">
        <input type="text" class="form-control rounded-3" id="quantity" placeholder="" name="quantity">
        <label for="quantity">Quantity</label>
    </div>
    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Save</button>
</form>
<script>
    function handleNewProduct(event){
        
        let toShow = document.getElementById('genericHolder');
        if(event.target.value != 'health-care'){
            toShow.classList.add('d-none');
        }else{
            toShow.classList.remove('d-none');
        }
    }
    function addOption(value, text) {
        var select = document.getElementById("productName");
        var option = document.createElement("option");
        option.value = value;
        option.text = text;
        select.appendChild(option);
    }

    // Example usage
    // addOption("value1", "Option 1");
</script>
