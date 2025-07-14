export interface Message {
    id: number;
    user_id: number;
    username: string;
    message: string;
    timestamp: string;
    avatar?: string;
}

export interface MessageWebSocket extends Omit<Message, 'id'> {}
