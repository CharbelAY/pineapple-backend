<div class="row pt-5">
    <div class="col-lg-3" align="center">
        <h1>Filtering</h1>
        <hr class="mb-5">
        <form action="" id="filteringForm">
            <div class="input-group mb-3">
                <span class="input-group-text" id="email-label">email</span>
                <input type="email" class="form-control" placeholder="Enter searched email here..." name="email" >
            </div>
                <select class="form-select mb-3" name="date-sorting">
                    <option value="" disabeled selected>Sort by date</option>
                    <option value="Ascending">Ascending</option>
                    <option value="Descending">Descending</option>
                </select>
            <select class="form-select mb-3" name="provider-sorting">
                <option disabeled selected>Sort by provider</option>
                <option value="gmail">gmail</option>
                <option value="yahoo">yahoo</option>
                <option value="outlook">outlook</option>
            </select>
            <button class="btn btn-primary mt-2 w-100" type="submit" form="filteringForm">Filter</button>
        </form>

        <h1 class="mt-5">Actions</h1>
        <hr class="mb-5">
        <button class="btn btn-danger w-100" type="submit" form="tableForm">Delete Selected Items</button>

    </div>
    <div class="col-lg-9 gx-5">
        <form name="tableForm" action="/deleteEmails" method="post" id="tableForm">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Selected</th>
                    <th scope="col">Email</th>
                    <th scope="col">Provider</th>
                    <th scope="col">Subscribed at</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><input type="checkbox" name="<?= $user["id"] ?>"></td>
                        <td><?= $user["email"] ?></td>
                        <td>.com</td>
                        <td><?= $user["created_at"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </form>
    </div>

</div>