src="https://www.paypal.com/sdk/js?client-id=Acayc5uYOLXNydlUplMuYdXKVKwxuG1krYrmc6_m9FUwIx7Rk_6zOLFzF4_YdZFSdWRfbt0_pf0wOcXb&components=buttons&vault=true&intent=subscription"

paypal.Buttons({
  style: {
    layout: 'vertical',
    color:  'blue',
    shape:  'rect',
    label:  'paypal'
  }
}).render('#paypal-button-container');