
<?php



if($_POST){
    
    $product = new WC_Product_Simple();

    $product->set_name( $_POST['productname'] ); // product title

    $product->set_regular_price( $_POST['productprice'] ); // in current shop currency

    $product->set_short_description( $_POST['productdesc'] );
    // you can also add a full product description
    // $product->set_description( 'long description here...' );

    $product->set_image_id( 90 );

    // let's suppose that our 'Accessories' category has ID = 19 
    $product->set_category_ids( array( 19 ) );
    // you can also use $product->set_tag_ids() for tags, brands etc

    $product_id = $product->save();
   

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
               
                // deb($movefile);
                
                $filename = $movefile['file'];
                
                
                $parent_post_id = $product_id;
                $filetype = wp_check_filetype( basename( $filename ), null );
                $wp_upload_dir = wp_upload_dir();
                $filex = $wp_upload_dir['path'] . '/' . basename( $filename);
                // deb($wp_upload_dir['subdir']."/".basename( $filename));
                // deb($wp_upload_dir);exit();
// Prepare an array of post data for the attachment.
$attachment = array(
	'guid'           => $movefile['url'], 
	'post_mime_type' => $filetype['type'],
	'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
	'post_content'   => '',
	'post_status'    => 'inherit'
);

              
if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
}

                $attach_id = wp_insert_attachment( $attachment, $file['name'], $product_id );
                $attach_data = wp_generate_attachment_metadata( $attach_id, $filex );
                wp_update_attachment_metadata( $attach_id, $attach_data );
                set_post_thumbnail( $product_id, $attach_id );
                            
               
            }
        }
    }

}


?>
           
            <br><br>
           
                <form action="" method="post" enctype="multipart/form-data">
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Image</label>
                         <div id="imagediv" >
                            <div>
                                <input type="file" onchange="filechange(this)" class="productimage woocommerce-Input woocommerce-Input--text input-text" accept="image/*" name="productimage[]" />
                                <div class="imgplace"></div>
                            </div>
                           
                        </div>
                    </p>

                    <svg id="addproductimage" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg>
<svg id="delproductimage"  style="display:none;color:red;" class="delimg"  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
  <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
</svg>

                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Video (Youtube URL)</label>
                         <div id="videodiv" >
                            <div>
                                <input type="text" class="productvideo woocommerce-Input woocommerce-Input--text input-text" name="productvideo[]" />
                            </div>
                        </div>
                    </p>
                    

                   

                    <svg id="addproductvideo" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
</svg>
<svg id="delproductvideo"  style="display:none;color:red;" class="delimg"  xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
  <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
</svg>
                   
                   

                    
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Name</label>
                        
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="productname" />
                          
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Description</label>
                        
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="productdesc" />
                          
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Product Price (RM)</label>
                        
                                <input type="number" class="woocommerce-Input woocommerce-Input--text input-text" name="productprice" />
                          
                    </p>
                    <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                        <label for="matricno">Contact Option</label>
                        
                                <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="contactno" />
                          
                    </p>




                    <br><br>
                    <input id="addproduct" type="button" value="Cancel" />
                    <input type="submit" name="Delete Product" value="Delete" />
                <input type="submit" name="Add Product" value="Update" />
                </form>
           
            
             
             <!-- <button id="delproductimage">Delete Product Image</button> -->

        
    


<script>

    function filechange(e){
        e.nextElementSibling.innerHTML = `<img src="${URL.createObjectURL(e.files[0])}" width="100px" height="100px" />`;
        console.log(e.nextElementSibling);
        // console.log(e.parentElement.parentElement);
        // e.parentElement.parentElement.removeChild(e.parentElement.parentElement.lastElementChild);
        
        }
    // function myFunctiondel(e){
    //     console.log(e.parentElement.parentElement);
    //     e.parentElement.parentElement.removeChild(e.parentElement.parentElement.lastElementChild);
        
    //     }

    window.addEventListener('load', function(event) {

//         document.querySelector("#myfileupload").addEventListener("change", (e) => {
//                 var myele = document.querySelector("#imagediv") ; 
//                 var copyhtml = document.querySelector("#imagediv").innerHTML ;
//                 myele.innerHTML = copyhtml + `<div class="divfileupload"><svg onclick="myFunctiondel(this)" class="delimg" style="color:red;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16">
//   <path d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15h9.286zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1zM.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8H.8z"/>
// </svg><input type="file" value="${e.target.files}" name="productimage[]" style="display:none"><img src="${URL.createObjectURL(e.target.files[0])}" width="100px" height="100px" /></div>` ; 

//         });
        
						document.querySelector("#addproduct").addEventListener("click", () => {

                             var base_url = window.location.origin;
                            // "http://stackoverflow.com"
                            var host = window.location.host;
                            var pathArray = window.location.pathname.split( '/' );

                            window.location.href = `${base_url}/my-account/myproduct/` ;

                        }); 

                       

                        // for(let i = 0 ; i < myelex.length ; i ++){
                        //     myelex.childNodes[i]
                        // }
                        // console.log("myele",myelex.childNodes);

                        // document.querySelectorAll(".divfileupload").addEventListener("click", () => {

                        //    alert("ddd");

                        //     }); 

                        document.querySelector("#addproductimage").addEventListener("click", () => {
                            var newNode = document.createElement('div');
                            newNode.innerHTML = `<input type="file" onchange="filechange(this)" class="productimage woocommerce-Input woocommerce-Input--text input-text" accept="image/*" name="productimage[]" />
                            <div class="imgplace"></div>`;
                            var parentNode = document.querySelector('#imagediv');
                            parentNode.append(newNode);
                           

                            // var myele = document.querySelector("#imagediv") ; 
                            // let copyhtml = document.querySelector("#imagediv").innerHTML ; 
                            //             myele.innerHTML = copyhtml + `<div><input type="file" onchange="filechange(this)" class="productimage woocommerce-Input woocommerce-Input--text input-text" accept="image/*" name="productimage[]" />
                            // <div class="imgplace"></div></div>` ;

                            var countfile = document.querySelector("#imagediv");
                                        console.log("countfile",countfile.children.length);
                                        if(countfile.children.length == "2"){
                                            document.querySelector("#delproductimage").style.display = "inline-block";
                                        }

                        }); 

                          document.querySelector("#delproductimage").addEventListener("click", () => {
                          
                                var parent = document.querySelector("#imagediv");
                                parent.removeChild(parent.lastElementChild);
                                var countfile = document.querySelector("#imagediv");
                                console.log("countfile",countfile.children.length);
                                if(countfile.children.length == "1"){
                                    document.querySelector("#delproductimage").style.display = "none";
                                }
                            }); 


                        document.querySelector("#addproductvideo").addEventListener("click", () => {
                            var newNode = document.createElement('div');
                            newNode.innerHTML = `<input type="text" class="productvideo woocommerce-Input woocommerce-Input--text input-text" name="productvideo[]" />`;
                            var parentNode = document.querySelector('#videodiv');
                            parentNode.append(newNode);
                            var countfile2 = document.querySelector("#videodiv");
                                        console.log("countfile",countfile2.children.length);
                                        if(countfile2.children.length == "2"){
                                            document.querySelector("#delproductvideo").style.display = "inline-block";
                                        }

                        }); 

                        document.querySelector("#delproductvideo").addEventListener("click", () => {
                          
                          var parent = document.querySelector("#videodiv");
                          parent.removeChild(parent.lastElementChild);
                          var countfile = document.querySelector("#videodiv");
                          console.log("countfile",countfile.children.length);
                          if(countfile.children.length == "1"){
                              document.querySelector("#delproductvideo").style.display = "none";
                          }
                      }); 

    
	}); 
</script>
