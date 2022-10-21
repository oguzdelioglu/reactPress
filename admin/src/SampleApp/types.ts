import { EntityReference } from "@camberi/firecms";

export type Product = {
    name: string;
    main_image: string;
    category:string;
    available: boolean;
    price: number;
    currency: string;
    public: boolean;
    brand: string;
    description: string;
    amazon_link: string;
    images: string[];
    related_products: EntityReference[];
    publisher: {
        name: string;
        external_id: string;
    },
    available_locales: string[],
    uppercase_name: string,
    added_on: Date;
}


export type Locale = {
    name: string,
    description: string,
    selectable?: boolean,
    video: string
}

export type Category = {
    name: string,
    slug: string
}

export type Setting = {
    title: string,
    description: string,
    keywords: string,
    author: string,
    canonical: string,
    site_header_meta: string,
    site_ads_300_250: string,
    site_ads_fluid: string,
    site_ads_responsive: string
}
