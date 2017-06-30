<div style="width: 680px;">
  <p style="margin-top: 0px; margin-bottom: 20px;">Thank you for your interest in {{storeName}} products. Your order has been received and will be processed once payment has been confirmed.</p>
  {{orderLink}}
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;" colspan="2">
            Order Details
        </td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
          <b>Order ID:</b> {{orderId}}<br />
          <b>Date of Order:</b> {{dateAdded}}<br />
          <b>Payment Method:</b> {{paymentMethod}}<br />
          {{shippingMethod}}
          </td>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
          <b>Email:</b> {{email}}<br />
          <b>Telephone:</b> {{telephone}}<br />
          <b>Status:</b> {{orderStatus}}<br />
        </td>
      </tr>
    </tbody>
  </table>
  <table style="border-collapse: collapse; width: 100%; border-top: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; margin-bottom: 20px;">
    <thead>
      <tr>
        <td style="font-size: 12px; border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; background-color: #EFEFEF; font-weight: bold; text-align: left; padding: 7px; color: #222222;">
            Billing Address
        </td>
        {{shippingAddressTitle}}
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size: 12px;	border-right: 1px solid #DDDDDD; border-bottom: 1px solid #DDDDDD; text-align: left; padding: 7px;">
            {{paymentAddress}}
        </td>
        {{shippingAddress}}
      </tr>
    </tbody>
  </table>
  {{orderProducts}}
  <p style="margin-top: 0px; margin-bottom: 20px;">Please reply to support@whatacart.com if you have any questions.</p>
  <p>
      Thanks,<br/>
      System Admin
  </p>
</div>