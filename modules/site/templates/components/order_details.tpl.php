      <table class="table table-bordered">
        <tbody>
          <tr>
            <th>您购买的电影票种类</th>
            <td><?php echo $ticket['name'] ?></td>
          </tr>
          <tr>
            <th>您购买的张数</th>
            <td><?php echo $ticket_num ?></td>
          </tr>
          <tr>
            <th>单张票价</th>
            <td>$<?php echo $ticket['cost']+$ticket['margin'] ?></td>
          </tr>
          <th>总支付金额</th>
          <td class="total"><strike><strong>$<?php echo round($ticket_num * $ticket['original_cost'], 2);  ?></strong></strike>&nbsp;&nbsp;&nbsp;<strong style="color:#31708F;">$<?php echo round($ticket_num * ($ticket['cost'] + $ticket['margin']), 2) ?></strong></td>
        </tr>
        </tbody>
      </table>