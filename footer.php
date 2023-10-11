                </section>
            </div>
        </div>
        <div class="footer-container-full">
            <footer class="footer container">
                <div class="region region-footer">
                    <section id="block-block-24" class="block block-block col-xs-12 col-md-4 clearfix">
                        <p>&nbsp;</p>
                        <p>Copyright © 2017. LXQ-CAD. All Rights Reserved.</p>
                    </section>
                </div>
            </footer>
        </div>
        <!-- jQuery -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!--  validator -->
        <script type="text/javascript" src="js/validator.js"></script>
        <script type="text/javascript" src="js/moment.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
        <script type="text/javascript" src="js/datatables.min.js"></script>
        <script>
            $('#sr_students_dob').datetimepicker({
                viewMode: 'days',
                format: 'DD-MM-YYYY'
            });      

        $('#select-student').change(function()
        {
            $.post("inc/ajax_courses.php", {'student_id' : this.value},
                function(data) {
                    var sel = $("#select-course");
                    sel.empty();
                    sel.append(data);
                });
        });

        <?php 
        if(isset($tables_list)) {
            foreach($tables_list as $value)
                echo "$(document).ready(function() {  $('#{$value}_datatable').dataTable( {'scrollY': '400px', 'scrollCollapse': true, 'paging': false,  'ordering': false,  'info': false, 'bFilter': false  } ); });"; 
        }
        ?>    
        
        function addCommas(t) { return "$"+String(t).replace(/(\d)(?=(\d{3})+$)/g, "$1,"); }
        function delCommas(t) { return String(t).replace(/[\$,]/g, ""); }
    
        function focusFunction(elem)
        {
            elem.value = delCommas(elem.value);
        }
        function blurFunction(elem)
        {
            elem.value = addCommas(elem.value);
        }

        function check(prefix, cb, type){
            var all = document.getElementById(prefix+"_all");
            var els = document.getElementsByName(prefix+"_check_list[]");

            if (type == 2) {
                for(var i = 0; i < els.length; ++i)
                   els[i].checked = cb.checked;
            } 
            else if( type == 1 && cb.checked == false) {
                all.checked = false;
            }

            var one_checked = false;
            var all_checked = true;

            for(var i = 0; i < els.length; ++i) {
               if(els[i].checked)
                   one_checked = true;
               else
                   all_checked = false; 
            }
            if(all_checked) all.checked = true;
            document.getElementById(prefix+"_delete").disabled = !one_checked;
        }
/*        function check(prefix, cb, type){
            var all = document.getElementById(prefix+"_all");

            if (type == 2) {
                var els = document.getElementsByName(prefix+"_check_list[]");
                for(var i = 0; i < els.length; ++i)
                   els[i].checked = cb.checked;
            } 
            else if( type == 1 && cb.checked == false) {
                all.checked = false;
            }
        }*/
       <?php
        if(isset($email_module)) {
       ?> 

        function email_module() {
            var elem = document.getElementById("myBar");   
            var width = 1;
            var id = setInterval(frame, 500);
            var values = "E";
            document.getElementById("idSendEmail").disabled=true;
            $.post( "inc/controller_pdf.php",values, function(data) {
                document.getElementById("myResults").innerHTML = data;
                //alert(data);
                clearInterval(id);
                elem.innerHTML = "100%";
                elem.style.width = '100%'; 
                $('#myModalExec').modal('show');
            });

            function frame() {
                $.getJSON( "inc/status.php", function(progress) {
                    elem.style.width = progress + '%';
                    elem.innerHTML = progress + '%';
               });
            }
        }
       <?php } ?>
       </script>
        <!-- /Datatables -->
    </body>
</html>