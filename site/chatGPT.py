import openai

# Replace 'your-api-key' with your actual OpenAI API key
openai.api_key = ''

def chat_with_gpt(prompt):
    response = openai.ChatCompletion.create(
        model="gpt-3.5-turbo",  # or "gpt-3.5-turbo" if you prefer
        messages=[
            {"role": "system", "content": "You are ChatGPT, a helpful assistant."},
            {"role": "user", "content": prompt},
        ]
    )
    
    # Extract the assistant's reply
    reply = response.choices[0].message['content']
    return reply

if __name__ == "__main__":
    user_input = input("You: ")
    reply = chat_with_gpt(user_input)
    print("ChatGPT: " + reply)
