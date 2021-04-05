<div class="row pt-5">
    <div class="col-lg-3" align="center">
        <h1>Filtering</h1>
        <hr class="mb-5">
        <form action="">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="email" class="form-control" placeholder="Enter searched email here..." aria-label="email"
                       aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <select class="form-select" aria-label="Default select">
                    <option selected>Filter by date</option>
                    <option value="1">Ascending</option>
                    <option value="2">Descending</option>
                </select>
            </div>
            <select class="form-select" aria-label="Default select">
                <option selected>Filter by provider</option>
                <option value="1">.com</option>
                <option value="2">.fr</option>
                <option value="3">.us</option>
            </select>
            <button class="btn btn-primary mt-2" type="submit" form="">Filter</button>
        </form>

        <h1 class="mt-5">Actions</h1>
        <hr class="mb-5">
        <button class="btn btn-danger" type="submit" form="tableForm">Delete Selected Items</button>

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