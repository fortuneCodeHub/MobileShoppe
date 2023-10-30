<?php include_once "htmlscripts.php"; ?>

        <header class="navbar navbar-dark sticky-top shadow navbar-expand-md bg-dark" style="padding: 3px 0px;" id="header">
            <div class="container">
              <a class="navbar-brand nav-fonts font-weight-600 font-size-20" href="#">Mobile Shopee</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="input-group my-3 my-sm-0 pe-2">
                  <input class="form-control bg-light text-dark me-2" type="text" placeholder="Search" style="border: none;">
                <button class="btn text-light" id="btn-style" name="search" type="submit">Search</button>
              </div>
              <ul class="text-center d-flex align-items-center justify-content-between mt-2 list-unstyled">
                <li>
                  <a class="font-size-14 link-style-2 me-4" href="#">Profile</a>
                </li>
                <li>
                  <a class="font-size-14 link-style-2" href="include/logout.inc.php">Logout</a>
                </li>
              </ul>
            </div>
          </header>