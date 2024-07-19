import GuestLayout from '@/Layouts/GuestLayout';
import { Button } from '@/shadcn/ui/button';
import { PageProps } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { MousePointer } from 'lucide-react';

export default function Welcome({ auth, laravelVersion, phpVersion }: PageProps<{ laravelVersion: string, phpVersion: string }>) {
    const handleImageError = () => {
        document.getElementById('screenshot-container')?.classList.add('!hidden');
        document.getElementById('docs-card')?.classList.add('!row-span-1');
        document.getElementById('docs-card-content')?.classList.add('!flex-row');
        document.getElementById('background')?.classList.add('!hidden');
    };

    return (
        <>
            <GuestLayout>
                <Head title="Welcome" />
                <div className="mx-auto grid w-[350px] gap-6">
                    <div className="grid gap-3">
                        <h1 className="text-3xl font-bold">Rapid Wallet</h1>
                        <p className="text-balance text-muted-foreground">
                            Rapid Wallet is an integrated web application designed for testing purposes, combining Laravel as the backend API and Inertia.js with React.js as the frontend.
                        </p>
                        <div className='mt-3'>
                            <Button asChild>
                                <Link href="/login" className='flex gap-1 items-center'>
                                    <MousePointer size={18} /> Click Here
                                </Link>
                            </Button>
                        </div>
                    </div>
                </div>
            </GuestLayout>
        </>
    );
}
