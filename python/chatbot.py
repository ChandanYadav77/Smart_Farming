# chatbot.py
import sys
import requests

question = sys.argv[1]

response = requests.post(
    response = requests.post(
    "http://localhost:11434/api/generate",
    json={
        "model": "llama3",
        "prompt": user_input,
        "stream": False
    },
    proxies={"http": None, "https": None}  # <--- bypass proxy
)

)

data = response.json()
print(data["response"])
