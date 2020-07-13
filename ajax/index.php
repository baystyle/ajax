<script type="text/javascript" src="jquery-3.5.1.min.js"></script>
<script>
    function loadPage() {  
            $("#table").load("getData.php")
    }

    window.onload = function () {  
        setInterval('loadPage()',1000*1)
    }
</script>

<div id="table"></div>