
<?php

if($_FILES){
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    // for multiple file upload.
    $upload_overrides = array( 'test_form' => false );
    $files = $_FILES['productimage'];
    foreach ( $files['name'] as $key => $value ) {
        if ( $files['name'][ $key ] ) {
            $file = array(
                'name' => $files['name'][ $key ],
                'type' => $files['type'][ $key ],
                'tmp_name' => $files['tmp_name'][ $key ],
                'error' => $files['error'][ $key ],
                'size' => $files['size'][ $key ]
            );

            $movefile = wp_handle_upload( $file, $upload_overrides );
            deb($movefile);
        }
    }
}


?>
            <button id="addproduct">View My Product</button>
            <br><br>
            <div id="imagediv">
                <form action="" method="post" enctype="multipart/form-data">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Image</label>
                        <input type="file" class="woocommerce-Input woocommerce-Input--text input-text" accept="image/*" name="productimage[]" />
                    </p>
                <input type="submit" name="" value="Add Product Image" />
                </form>
            </div>
            
             
             <!-- <button id="delproductimage">Delete Product Image</button> -->

        
    


<script>
    window.addEventListener('load', function(event) {
						document.querySelector("#addproduct").addEventListener("click", () => {

                             var base_url = window.location.origin;
                            // "http://stackoverflow.com"
                            var host = window.location.host;
                            var pathArray = window.location.pathname.split( '/' );

                            window.location.href = `${base_url}/my-account/myproduct/` ;

                        }); 

                        // document.querySelector("#addproductimage").addEventListener("click", () => {
                        //     var myele = document.querySelector("#imagediv") ; 
                        //     let copyhtml = document.querySelector("#imagediv").innerHTML ; 
                        //                 myele.innerHTML = copyhtml + `<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        //         <label for="matricno">Product Image</label>
                        //         <input type="file" class="woocommerce-Input woocommerce-Input--text input-text" name="productimage[]" />
                        //     </p>` ;

                        //     var countfile = document.querySelector("#imagediv");
                        //                 console.log("countfile",countfile.children.length);
                        //                 if(countfile.children.length == "2"){
                        //                     document.querySelector("#delproductimage").style.display = "block";
                        //                 }

                        // }); 

                        //   document.querySelector("#delproductimage").addEventListener("click", () => {
                          
                        //         var parent = document.querySelector("#imagediv");
                        //         parent.removeChild(parent.lastElementChild);
                        //         var countfile = document.querySelector("#imagediv");
                        //         console.log("countfile",countfile.children.length);
                        //         if(countfile.children.length == "1"){
                        //             document.querySelector("#delproductimage").style.display = "none";
                        //         }
                        //     }); 

    
	}); 
</script>
