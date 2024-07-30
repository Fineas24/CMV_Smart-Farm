import base64
import requests

class ImageRecognition():
    def __init__(self, image_path):
        # OpenAI API Key
        api_key = 

        # Function to encode the image
        def encode_image(image_path):
            with open(image_path, "rb") as image_file:
                return base64.b64encode(image_file.read()).decode('utf-8')

        # Getting the base64 string
        base64_image = encode_image(image_path)

        headers = {
            "Content-Type": "application/json",
            "Authorization": f"Bearer {api_key}"
        }

        payload = {
            "model": "gpt-4o",
            "messages": [
                {
                    "role": "user",
                    "content": [
                        {
                            "type": "text",
                            "text": "Spune-mi numele popular al organismului si cu ce solutie trebui stropit pentru a-l neutraliza(daca dauna recoltei) in formatul asta: {numele speciei}/{numele solutiei}, daca nu trebuie stropit cu nimic scrie in loc de numele solutiei: inofensiv si sa raspunzi mereu in formatul respectiv nume/solutie, astfel vor fi erori in codul meu"
                        },
                        {
                            "type": "image_url",
                            "image_url": {
                                "url": f"data:image/jpeg;base64,{base64_image}"
                            }
                        }
                    ]
                }
            ],
            "max_tokens": 300
        }

        self.response = requests.post("https://api.openai.com/v1/chat/completions", headers=headers, json=payload)
    def informatii(self):
        return(self.response.json()['choices'][0]['message']['content'].split('/'))


