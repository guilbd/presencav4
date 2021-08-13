var now = new Date;
if ((now.getHours() == 19 && (now.getMinutes() >= 0 || now.getMinutes() < 16)) || 
(now.getHours() == 21 && (now.getMinutes() >= 0 || now.getMinutes() < 31)) || 
((now.getHours() == 22 && now.getMinutes() > 44) || (now.getHours() == 23 && now.getMinutes() > 6))) {
    console.log("dentro do prazo")
} else {
    console.log("fora do prazo")
}