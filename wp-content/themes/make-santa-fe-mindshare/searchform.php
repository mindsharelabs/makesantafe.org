<form action="<?php echo home_url(); ?>" method="get" class="form-block">
    <fieldset>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search" name="s" id="search" value="<?php the_search_query(); ?>" aria-label="Search here">
            <span class="input-group-append">
				<button type="submit" class="btn btn-primary">Search</button>
			</span>
        </div>
    </fieldset>
</form>
