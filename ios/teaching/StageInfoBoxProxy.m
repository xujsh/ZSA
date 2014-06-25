//
//  StageInfoBoxProxy.m
//  teaching
//
//  Created by kidliuxu on 14-1-7.
//  Copyright (c) 2014年 icesmart. All rights reserved.
//

#import "StageInfoBoxProxy.h"

@implementation StageInfoBoxProxy
@synthesize infoType;

- (id) initWithInfoType:(NSString *) infoTypeStr
{
    self = [self init];
    if(self)
    {
        self.infoType = infoTypeStr;
    }
    return self;
}


- (void) saveStrValueByKey:(NSString *) infoKey value:(NSString *) infoValue
    {
        NSMutableDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        NSMutableDictionary *saveDic = [NSMutableDictionary dictionaryWithDictionary:dictionary];
        [saveDic setObject:infoValue forKey:infoKey];
        [[NSUserDefaults standardUserDefaults] setObject:saveDic forKey:self.infoType];
    }

- (void) saveBoolValueByKey:(NSString *) infoKey value:(BOOL) infoValue
    {
        //NSMutableDictionary * mutableDictionary = [NSMutableDictionary dictionaryWithCapacity:5];
        //[mutableDictionary setValue:@"aaa" forKey:@"bbb"];
        //[mutableDictionary setObject:@"good lucky" forKey:@"why"];
        //NSLog(@"aaa %@", [mutableDictionary valueForKey:@"why"]);


        NSDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        NSMutableDictionary *saveDic = [NSMutableDictionary dictionaryWithDictionary:dictionary];

        NSString *strValue = @"1";
        if(!infoValue)
        {
            strValue = @"0";
        }
        if (dictionary == nil)
        {
            NSLog(@"nil");
        }
        else
        {
            NSLog(@"have");
        }
        NSLog(@"dictionary: %@", dictionary);
        NSLog(@"save bool value: %@ and key:%@", strValue, infoKey);
        [saveDic setValue:strValue forKey:infoKey];
        [[NSUserDefaults standardUserDefaults] setObject:saveDic forKey:self.infoType];
    }

- (void) saveIntValueByKey:(NSString *) infoKey vlaue:(int) infoValue
    {
        NSMutableDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        NSMutableDictionary *saveDic = [NSMutableDictionary dictionaryWithDictionary:dictionary];
        NSString *strValue = [NSString stringWithFormat:@"%i", infoValue];
        [saveDic setObject:strValue forKey:infoKey];
        [[NSUserDefaults standardUserDefaults] setObject:saveDic forKey:self.infoType];
    }

- (NSString *) loadStrValueByKey:(NSString *) infoKey
    {
        NSMutableDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        return [dictionary objectForKey:infoKey];
    }

- (BOOL) loadBoolValueByKey:(NSString *) infoKey;
    {
        NSMutableDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        NSString *boolStr = [dictionary objectForKey:infoKey];
        if([boolStr isEqualToString:@"1"])
        {
            return YES;
        }
        else
        {
            return NO;
        }
    }

- (int) loadIntValueByKey:(NSString *) infoKey
    {
        NSMutableDictionary *dictionary = [[NSUserDefaults standardUserDefaults] objectForKey:self.infoType];
        //NSLog(@"load int str: %@",  (NSString *) [dictionary objectForKey:infoKey]);
        //NSLog(@"load int int: %i",  [(NSString *) [dictionary objectForKey:infoKey] intValue]);
        int value = [(NSString *) [dictionary objectForKey:infoKey] intValue];
        return value;
    }

@end
