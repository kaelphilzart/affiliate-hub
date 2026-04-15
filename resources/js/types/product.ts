import { ICategory } from "./category";

export interface IProduct {
    id: string;
    name: string;
    category: ICategory;
    link: string;
    image: string;
    image_url?: string;
    type: string;
    clicks?: number;
    created_at: Date;
    updated_at: Date;
}

export interface ICreateProduct {
    name: string;
    category_id: string;
    link: string;
    image: File | string | null
    type: string;
}

export interface IUpdateProduct {
    id?: string;
    name?: string;
    category_id?: string;
    link?: string;
    image?: File | string | null; 
    type?: string;
}