export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};

export interface Transactions {
    id: number;
    user_id: number;
    order_id: string;
    amount: number;
    timestamp: string;
    type: string;
    status: number;
}
