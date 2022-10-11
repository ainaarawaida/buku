
<button id="addproduct">Add Product</button>



<script>
    window.addEventListener('load', function(event) {
						document.querySelector("#addproduct").addEventListener("click", () => {

                            var base_url = window.location.origin;
                            // "http://stackoverflow.com"
                            var host = window.location.host;
                            var pathArray = window.location.pathname.split( '/' );

                            window.location.href = `${base_url}/my-account/myproduct/add` ;

                        }); 
                       

    
					}); 
</script>