export default class EmailStrategy{

    async send(notification){
        console.log(`Notification type :- email Notification: ${notification.message}`)
    }
}