export default  class SMSStrategy{

    async send(notification){
        console.log(`Notification type :- SMS Notification: ${notification.message}`)
    }
}