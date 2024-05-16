import telebot
from telebot import types
from config import TOKEN
# Замените 'YOUR_BOT_TOKEN' на токен вашего бота, полученный от BotFather в Telegram

bot = telebot.TeleBot(TOKEN)

# Список ID всех пользователей, которые написали боту
user_ids = set()

class A:
    a = 0
    
aboba = A()

# Команда /start
@bot.message_handler(commands=['start'])
def send_welcome(message):
    user_ids.add(message.from_user.id)
    bot.reply_to(message, "Добро пожаловать! Нажмите на кнопку, чтобы отправить сообщение всем пользователям.")
    send_message_keyboard(message.chat.id)

# Функция для отправки клавиатуры с кнопкой
def send_message_keyboard(chat_id):
    global aboba
    markup = types.ReplyKeyboardMarkup(row_width=1, resize_keyboard=True)
    aboba.a += 1
    button = types.KeyboardButton(f'Кирилл Пидор {aboba.a} раз')
    markup.add(button)
    bot.send_message(chat_id, "Нажмите на кнопку ниже, чтобы отправить сообщение всем пользователям.", reply_markup=markup)

# Обработчик всех сообщений
@bot.message_handler(func=lambda message: True)
def forward_message(message):
    global aboba
    # Пересылаем сообщение всем пользователям из списка, кроме отправителя
    for user_id in user_ids:
        if user_id != message.from_user.id:
            try:
                aboba.a += 1
                bot.forward_message(user_id, message.chat.id, message.message_id)
            except Exception as e:
                print(f"Ошибка при пересылке сообщения пользователю {user_id}: {e}")

# Обработчик нажатия на кнопку
@bot.message_handler(func=lambda message: message.text == 'Кирилл Пидор')
def on_button_click(message):
    for user_id in user_ids:
        try:
            bot.send_message(user_id, "Кирилл Пидор")
        except Exception as e:
            print(f"Ошибка при отправке сообщения пользователю {user_id}: {e}")




if __name__ == '__main__':
    bot.polling(none_stop=True)