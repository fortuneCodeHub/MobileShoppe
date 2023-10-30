<header id="header">
            <div class="d-sm-flex justify-content-between align-items-center px-4">
                <p class="mt-2">No 10 Aiyefostr, off Victor Ogundipe road, Inside Anibaba, off <br>Iyana Isashi Road, Off Badagry Express way </p>
                <div class="font-size-14 mb-2 mb-sm-0">
                    <a href="login.php" class="px-4 border-right border-left link-style">
                        Login
                    </a>
                    <a href="wishlist.php" class="px-4 border-right link-style">
                        <?php 
                        if (!empty($_SESSION["wishlist"])) {
                            foreach($_SESSION["wishlist"] as $key => $value) {
                                $count = count($_SESSION["wishlist"]);
                            }   
                        } elseif (isset($_SESSION["cus_user_id"])) {
                             
                            $sql = "SELECT * FROM wishlist WHERE cus_user_id = :cus_user_id";
                            $statement = $conection->prepare($sql);
                            $statement->bindParam(":cus_user_id", $_SESSION["cus_user_id"]);
                            $statement->execute();
                            $wishlist_count = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($wishlist_count as $i => $value) {
                                $i++;
                            }
                            $count = $i ?? 0;
                        } else {
                            $_SESSION["wishlist"] = null;
                            $_SESSION["cus_user_id"] = null;
                            $count = 0;
                        }
                            
                        ?>
                        Wishlist(<?php echo $count; ?>)
                    </a>
                </div>
            </div>
        </header>