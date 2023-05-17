

                  <table class="table table-bordered">
                  <tbody>
                    @foreach($datalist as $k=>$val)
                      <tr>
                        
                      Total Checkouts ...................{{$val->total_check_outs}}</tr><br>
                        <tr>Total Check In`s ..............{{$val->total_check_ins}}</tr><br>
                        <tr>Total Rooms ...................{{$val->room_count}}</tr><br>
                        <tr>Occuppied Rooms.................{{$val->occupied_rooms}}</tr><br>
                        <tr>Total Users ....................{{$val->user_count}}</tr><br>
                        <tr>Total Payments ....................{{$val->total_payment}}</tr><br>
                        <tr>Total Corporates ....................{{$val->corporate_count}}</tr><br>
                        <tr>Total Tas ....................{{$val->ta_count}}</tr><br>
                        <tr>Total Otas ....................{{$val->ota_count}}</tr><br>
                        <tr>Total Fit ....................{{$val->fit_count}}</tr><br>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
