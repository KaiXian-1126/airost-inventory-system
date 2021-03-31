<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../css/header.css" />
        <link rel="stylesheet" type="text/css" href="../css/applicationform.css" />
        <title>Application Form</title>
    </head>
    <body>
        <div class="header">
            <img src="../img/logo.png" alt="Logo">
            <h1>Inventory System</h1>
        </div>
        <div class="refLink">
            <h2> Application Management System</h2>
            <a href="../homepage.html">Home Page</a><p>&nbsp>&nbsp</p><a href="viewapplication.html">Application List</a>
        </div>
        <hr>
        <div class="form">
            <input type="button" class="back" value="<< Back"/>
            <h2>Application Form</h2>
            <div class="grid_container">
                <p class="name">Applicant name:</p>
                <input class="name" type="text" name="username">

                <p class="applieddate">Applied date</p>
                <input class="applieddate" type="date" name="applieddate">

                <p class="itemborrow">Item wish to borrow:</p>
                <input class="itemborrow" type="text" name="itemborrow">
                <input class="search" type="button" name="search" value="Search">

                <p class="quantity">Quantity:</p>
                <input class="quantity" type="number" min="1" name="quantity">

                <p class="borrowdate">Borrow date:</p>
                <input class="borrowdate" type="date" name="borrowdate">

                <p class="returndate">Return date:</p>
                <input class="returndate" type="date" name="returndate">

                <p class="description">Description:</p>
                <textarea class="description" name="description"></textarea>

                <p class="status">Status:</p>
                <input class="status" type="text" name="status">

                <p class="personincharge">Person-in-charge:</p>
                <input class="personincharge" type="text" name="personincharge">

                <p class="approveddate">Approved Date:</p>
                <input class="approveddate" type="date" name="approveddate">

                <p class="reason">Reason:</p>
                <textarea class="reason" name="reason"></textarea>

                <input class="submit" type="submit" value="Submit">
            </div>

        </div>
    </body>
</html>
