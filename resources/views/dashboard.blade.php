<x-app-layout>
    <div name="header" class="head mx-10" style="margin-top: 6%;" >
        <h1 style="font-weight: 600; font-size: 2rem; color: black;">
        <div>{{ 'Hey, '}} <span style="color: #fdd93b; text-shadow: 1px 1px 2px black;">{{Auth::user()->name }}</span>{{  '  👋🏻'}}</div> 
    
        </h1>
        <div style="color: black; font-size: 1.2rem" class="font-Cal">{{'Start Tracking Your Fitness Journey!'}}</div>
</div>

    <style>
        .head{
            display: block;
            text-align:left;
        }
        .dashboard-container {
            padding: 3rem 0;
        }

        .grid-container {
            display: flex;
            flex-direction: row;
            gap: 1.5rem;
            /* width: 400px; */
            height: 400px;
            margin: 0 auto;
            padding-left: 20px;
            padding-right: 20px;
        }

        .dashboard-card {
            background: linear-gradient(to right, #d2d8d9,rgb(34, 39, 46));
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: box-shadow 0.3s ease-in-out;
            cursor: pointer;
            text-decoration: none;
            color: #1f2937;
            width: 400px;
        
            
        }

        .dashboard-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px #fdd93b;
}

        .dashboard-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dashboard-card p {
            font-size:1rem;
            font-weight: bold;
            color: white;
            text-shadow: #1f2937;
        }
    </style>

    <div class="dashboard-container">
        <div class="grid-container">
            
            <a href="{{ route('diet.index') }}" class="dashboard-card">
                <h3>{{ __('Diet Tracker 🥗📝') }}</h3>
                <p>{{ __('Count the calories you take in.') }}</p>
            </a>
            
            <a href="{{ route('workouts.index') }}" class="dashboard-card">
                <h3>{{ __('Exercise Tracker 🏋🏻📝') }}</h3>
                <p>{{ __('Track your sweat-burn.') }}</p>
            </a>
            
            <a href="{{ route('progress.index') }}" class="dashboard-card">
                <h3>{{ __('Progress Tracker 📈') }}</h3>
                <p>{{ __('Track your fitness journey.') }}</p>
            </a>
            
            <a href="{{ route('workout-guide.index') }}" class="dashboard-card">
                <h3>{{ __('Workout Guide 📖') }}</h3>
                <p>{{ __('Explore categorized exercises.') }}</p>
            </a>
        </div>
    </div>
</x-app-layout>
