                                    <table class="table table-striped table-bordered table-hover order-column data-table-selecter" id="dataTable-fetched-trainin">
                                        <thead>
                                            <tr>
                                                <th> id</th>
                                                <th> 省 </th>
                                                <th> 城市 </th>
                                                <th> 代码 </th>
                                                <th> 名称 </th>
                                                <th> 拼音 </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        foreach($data as $r){
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$r['id'].' </td>
                                                <td>
                                                   '.$r['fromtrain'].' 
                                                </td>
                                                <td>'.$r['totrain'].'</td>
                                                <td class="center">'.$r['trainno'].'</td>
                                                <td>
                                                   '.$r['cityname'].' 
                                                </td>
                                                <td>'.$r['starttime'].'</td>
                                                </tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
