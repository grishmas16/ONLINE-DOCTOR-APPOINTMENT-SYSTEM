from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from typing import Optional, Dict
import os
from pymongo import MongoClient
from datetime import datetime
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Configuration from .env
MONGODB_URL = os.getenv("MONGODB_URL", "mongodb://localhost:27017")
DATABASE_NAME = os.getenv("DATABASE_NAME", "medical_llm_db")
LLM_MODEL = os.getenv("LLM_MODEL", "dev-model")

# Initialize MongoDB (Optional fallback if not running)
try:
    client = MongoClient(MONGODB_URL, serverSelectionTimeoutMS=2000)
    client.admin.command('ping')
    db = client[DATABASE_NAME]
    interactions_collection = db["ai_interactions"]
    mongo_active = True
except Exception:
    mongo_active = False

app = FastAPI(title="eDoc Medical AI Backend")

class PredictRequest(BaseModel):
    prompt: str
    model: Optional[str] = LLM_MODEL
    context: Optional[Dict] = {}

class PredictResponse(BaseModel):
    prediction: str
    status: str = "success"

@app.post("/predict")
async def predict(request: PredictRequest):
    prompt_lower = request.prompt.lower()
    
    # Simple Mock AI Logic
    if "headache" in prompt_lower:
        prediction = "Headaches can be caused by stress or dehydration. Drink water and rest. If pain persists, see a doctor."
    elif "fever" in prompt_lower:
        prediction = "A fever indicates your body is fighting infection. Monitor your temperature and stay hydrated."
    elif "analyze" in prompt_lower:
        prediction = "Based on the clinical data provided, I recommend a follow-up consultation with a specialist for further evaluation."
    else:
        prediction = f"I've analyzed your query: '{request.prompt}'. Please consult with our eDoc professionals for a detailed diagnosis."

    # Log to MongoDB if active
    if mongo_active:
        interactions_collection.insert_one({
            "prompt": request.prompt,
            "prediction": prediction,
            "timestamp": datetime.utcnow()
        })

    return {"prediction": prediction}

@app.get("/health")
async def health():
    return {"status": "healthy", "mongodb": "connected" if mongo_active else "not connected"}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=9999)
