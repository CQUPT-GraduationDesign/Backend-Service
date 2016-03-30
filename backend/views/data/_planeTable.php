                                    <table class="table table-striped table-bordered table-hover order-column" id="dataTable_ex">
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
                                        foreach($rows as $r){
                                            echo'
                                            <tr class="odd gradeX">
                                                <td> '.$r['id'].' </td>
                                                <td>
                                                   '.$r['province'].' 
                                                </td>
                                                <td>'.$r['city'].'</td>
                                                <td class="center">'.$r['code'].'</td>
                                                <td>
                                                   '.$r['name'].' 
                                                </td>
                                                <td>'.$r['alphabetic'].'</td>
                                                </tr>';
                                        }
                                        ?>
                                        </tbody>
                                    </table>
