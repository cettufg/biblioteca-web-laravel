import { Notify } from 'quasar';

export function notifyPositive({message, position = 'top-right', timeout = 1000}){
    Notify.create({
        message: message,
        type: 'positive',
        position: position,
        timeout: timeout
    });
}

export function notifyNegative({message, position = 'top-right', timeout = 1000}){
    Notify.create({
        message: message,
        type: 'negative',
        position: position,
        timeout: timeout
    });
}
